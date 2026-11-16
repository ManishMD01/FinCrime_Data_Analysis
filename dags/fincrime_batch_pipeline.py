from datetime import datetime, timedelta

try:
    from airflow import DAG
    from airflow.operators.python import PythonOperator
except ImportError:
    DAG = None


def run_pipeline():
    pass


if DAG is not None:
    with DAG(
        dag_id="fincrime_batch_pipeline",
        start_date=datetime(2024, 1, 1),
        schedule_interval="@daily",
        catchup=False,
    ) as dag:
        PythonOperator(
            task_id="run_pipeline",
            python_callable=run_pipeline,
        )
