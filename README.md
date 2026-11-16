# Fincrime Intelligence

A comprehensive financial crime detection and analytics platform built with a modern tech stack for identifying fraudulent transactions, money laundering patterns, and other financial crimes.

## Overview

Fincrime Intelligence is an end-to-end platform that combines rule-based detection, machine learning models, network analysis, and interactive dashboards to help financial institutions detect and investigate financial crimes in real-time.

## Architecture

```
┌─────────────────┐     ┌──────────────────┐     ┌─────────────────┐
│   Frontend      │────▶│   Backend API    │────▶│   BigQuery      │
│   (PHP)         │     │   (FastAPI)      │     │   Data Lake     │
└─────────────────┘     └──────────────────┘     └─────────────────┘
                              │        │
                              ▼        ▼
                       ┌─────────────┐ ┌─────────────┐
                       │ ML Models   │ │ Rule Engine │
                       │ (Training/  │ │ (High-value,│
                       │  Inference) │ │  Velocity,  │
                       └─────────────┘ │  Structuring)│
                                     └─────────────┘
                              │
                              ▼
                       ┌──────────────────┐
                       │ Airflow DAGs     │
                       │ (Batch Pipeline) │
                       └──────────────────┘
```

## Tech Stack

### Backend (Python)
- **FastAPI** - High-performance async API framework
- **Google Cloud BigQuery** - Data warehouse for transaction analytics
- **scikit-learn / XGBoost** - ML model training and inference
- **Pydantic** - Data validation and serialization
- **Uvicorn** - ASGI server

### Frontend (PHP)
- **PHP 8.1+** - Server-side rendering
- **Composer** - Dependency management
- **Vanilla JS/CSS** - Lightweight frontend interactions

### Infrastructure
- **Docker & Docker Compose** - Container orchestration
- **Apache Airflow** - Batch pipeline orchestration
- **GitHub Actions** - CI/CD pipelines

## Project Structure

```
FinCrime_Data_Analysis/
├── backend-python/          # FastAPI backend service
│   ├── app/
│   │   ├── api/routes/      # API endpoints
│   │   │   ├── transactions.py
│   │   │   ├── detection.py
│   │   │   ├── analytics.py
│   │   │   ├── network.py
│   │   │   ├── models.py
│   │   │   └── contract.py
│   │   ├── core/            # Core configuration & security
│   │   │   ├── config.py
│   │   │   ├── security.py
│   │   │   └── contract.py
│   │   ├── detection/       # Rule-based & anomaly detection
│   │   │   ├── rules.py
│   │   │   └── anomaly_detection.py
│   │   ├── ml/              # Machine learning pipeline
│   │   │   ├── train.py
│   │   │   ├── predict.py
│   │   │   ├── evaluate.py
│   │   │   └── features.py
│   │   └── services/        # Business logic services
│   │       ├── analytics_service.py
│   │       ├── bigquery_service.py
│   │       └── prediction_service.py
│   ├── pyproject.toml
│   └── infra/docker/Dockerfile.python
│
├── frontend-php/            # PHP web frontend
│   ├── public/index.php     # Entry point
│   ├── app/
│   │   ├── views/           # Dashboard views
│   │   │   ├── dashboard.php
│   │   │   ├── transactions.php
│   │   │   ├── fraud-analytics.php
│   │   │   ├── investigations.php
│   │   │   └── network-analysis.php
│   │   └── Controllers/
│   ├── composer.json
│   └── infra/docker/Dockerfile.php
│
├── dags/                    # Airflow DAGs
│   └── fincrime_batch_pipeline.py
│
├── docs/                    # Documentation
│   ├── architecture.md
│   ├── data_dictionary.md
│   ├── ml_model_card.md
│   └── security.md
│
├── docker-compose.yml       # Local development stack
├── .env.example             # Environment template
├── .github/workflows/ci.yml # CI/CD pipeline
└── README.md                # This file
```

## Features

### Transaction Monitoring
- Real-time transaction ingestion and validation
- High-value transaction alerts
- Velocity-based anomaly detection
- Structuring/smurfing pattern detection

### Detection Engine
- **Rule-based Detection**: Configurable rules for known fraud patterns
- **Anomaly Detection**: Statistical and ML-based outlier detection
- **Network Analysis**: Entity relationship graphs for money laundering detection

### Machine Learning
- Feature engineering pipeline for transaction data
- Model training with cross-validation
- Automated model evaluation and registry
- Batch and real-time inference endpoints

### Analytics & Dashboards
- Transaction volume and value summaries
- Fraud rate trends and KPIs
- Network visualization for investigations
- Case management for investigators

### Batch Processing
- Daily ETL pipelines via Airflow
- Feature store updates
- Model retraining schedules
- Report generation

## Getting Started

### Prerequisites
- Docker & Docker Compose v2+
- Google Cloud Project with BigQuery API enabled
- GCP Service Account with BigQuery permissions

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd FinCrime_Data_Analysis
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your GCP credentials and project settings
   ```

3. **Start the stack**
   ```bash
   docker-compose up -d
   ```

4. **Access services**
   - Frontend: http://localhost:8080
   - Backend API: http://localhost:8000
   - API Health Check: http://localhost:8000/health
   - API Docs (Swagger): http://localhost:8000/docs

### Development

**Backend (Python)**
```bash
cd backend-python
pip install -e .
uvicorn app.main:app --reload --port 8000
```

**Frontend (PHP)**
```bash
cd frontend-php
composer install
php -S localhost:8080 -t public
```

**Airflow**
```bash
# Airflow runs in Docker; DAGs in ./dags are auto-discovered
docker-compose logs -f airflow-webserver
```

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/health` | Health check |
| GET | `/api/transactions` | List transactions |
| GET | `/api/analytics/summary` | Analytics summary |
| POST | `/api/detection/rules` | Run rule-based detection |
| GET | `/api/network/graph` | Network graph data |
| POST | `/api/models/train` | Trigger model training |

## Configuration

Key environment variables (see `.env.example`):

| Variable | Description | Default |
|----------|-------------|---------|
| `BACKEND_HOST` | Backend bind address | `0.0.0.0` |
| `BACKEND_PORT` | Backend port | `8000` |
| `BIGQUERY_PROJECT_ID` | GCP Project ID | Required |
| `BIGQUERY_DATASET` | BigQuery dataset name | `fincrime` |
| `GOOGLE_APPLICATION_CREDENTIALS` | Path to GCP key file | `/app/secrets/gcp-key.json` |
| `FRONTEND_URL` | Frontend base URL | `http://localhost:8080` |

## Data Dictionary

See [docs/data_dictionary.md](docs/data_dictionary.md) for table schemas and field definitions.

## ML Model Card

See [docs/ml_model_card.md](docs/ml_model_card.md) for model details, performance metrics, and limitations.

## Security

See [docs/security.md](docs/security.md) for authentication, authorization, and data protection guidelines.

## Testing

```bash
# Backend tests
cd backend-python
pytest

# Frontend tests
cd frontend-php
./vendor/bin/phpunit

# CI Pipeline
# Runs automatically on push/PR via GitHub Actions
```

## Deployment

### Production Considerations
- Use managed Cloud Run or GKE for backend/frontend
- Cloud Composer for Airflow
- Secret Manager for credentials
- Cloud Armor / WAF for API protection
- VPC Service Controls for data perimeter

### Docker Images
```bash
# Build production images
docker-compose -f docker-compose.yml -f docker-compose.prod.yml build
docker-compose -f docker-compose.yml -f docker-compose.prod.yml push
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For questions or issues, please open a GitHub issue or contact the maintainers.

---

**Note**: This project is currently in early development. Core functionality is scaffolded with placeholder implementations. See individual module files for implementation status.