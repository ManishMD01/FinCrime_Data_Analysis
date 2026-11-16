
from google.cloud import bigquery
from app.core.contract import CONTRACT_FIELD_NAMES, mapping_store


class BigQueryService:
    def __init__(self, project_id: str | None = None):
        self.client = bigquery.Client(project=project_id)

    def get_transaction_summary(
        self,
        table_id: str,
        start_date: str,
        end_date: str,
    ) -> list[dict]:
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
                bigquery.ScalarQueryParameter("start_date", "STRING", start_date),
                bigquery.ScalarQueryParameter("end_date", "STRING", end_date),
            ],
            maximum_bytes_billed=10_000_000_000,
        )

        rows = self.client.query(query, job_config=job_config).result()
        return [dict(row.items()) for row in rows]

    def resolve_select(self, table_id: str, limit: int = 100) -> str:
        mapping = mapping_store.get(table_id)
        if mapping is None:
            cols = ", ".join(CONTRACT_FIELD_NAMES)
            return f"SELECT {cols} FROM `{table_id}` LIMIT {limit}"

        selected = []
        for field in CONTRACT_FIELD_NAMES:
            col_mapping = mapping.mappings.get(field)
            if col_mapping and col_mapping.source_column:
                selected.append(f"`{col_mapping.source_column}` AS {field}")
            else:
                selected.append(f"NULL AS {field}")
        cols = ", ".join(selected)
        return f"SELECT {cols} FROM `{table_id}` LIMIT {limit}"
