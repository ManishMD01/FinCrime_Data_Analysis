
# backend-python/app/services/bigquery_service.py

from google.cloud import bigquery


def get_transaction_summary(
    client: bigquery.Client,
    table_id: str,
    start_date: str,
    end_date: str,
) -> list[dict]:
    # table_id must come from an approved server-side
    # configuration or allowlist, never raw user input.
    query = f"""
        SELECT
            DATE(transaction_timestamp) AS transaction_date,
            COUNT(*) AS transaction_count,
            SUM(amount) AS total_amount,
            COUNT(DISTINCT account_id) AS unique_accounts
        FROM `{table_id}`
        WHERE transaction_timestamp >=
              TIMESTAMP(@start_date)
          AND transaction_timestamp <
              TIMESTAMP(@end_date)
        GROUP BY transaction_date
        ORDER BY transaction_date
    """

    job_config = bigquery.QueryJobConfig(
        query_parameters=[
            bigquery.ScalarQueryParameter(
                "start_date", "STRING", start_date
            ),
            bigquery.ScalarQueryParameter(
                "end_date", "STRING", end_date
            ),
        ],
        maximum_bytes_billed=10_000_000_000,
    )

    rows = client.query(
        query,
        job_config=job_config,
    ).result()

    return [dict(row.items()) for row in rows]
