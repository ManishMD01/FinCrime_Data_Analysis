# Fincrime Intelligence

Financial crime detection and analytics platform.

## Structure

- `frontend-php/` - PHP web frontend
- `backend-python/` - Python backend API and ML services
- `sql/` - SQL queries for analytics, features, and detections
- `dags/` - Airflow batch pipelines
- `infra/` - Docker and BigQuery configuration
- `docs/` - Architecture, data dictionary, ML model card, security

## Getting Started

Copy `.env.example` to `.env` and configure environment variables.

```bash
docker-compose up -d
```
