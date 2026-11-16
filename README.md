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
- **Pydantic v2** - Data validation and serialization (with pydantic-settings)
- **Uvicorn** - ASGI server

### Frontend (PHP)
- **PHP 8.2+** - Server-side rendering with PSR-4 autoloading
- **Vanilla JS/CSS** - Lightweight frontend interactions (Chart.js for visualizations)
- **Apache** - Web server with mod_rewrite

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
│   ├── public/
│   │   ├── index.php        # Entry point with routing
│   │   ├── assets/
│   │   │   ├── css/style.css
│   │   │   └── js/app.js
│   ├── app/
│   │   ├── views/           # Dashboard views
│   │   │   ├── dashboard.php
│   │   │   ├── transactions.php
│   │   │   ├── fraud-analytics.php
│   │   │   ├── investigations.php
│   │   │   ├── network-analysis.php
│   │   │   └── layouts/main.php
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── TransactionsController.php
│   │   │   ├── FraudAnalyticsController.php
│   │   │   ├── InvestigationsController.php
│   │   │   └── NetworkAnalysisController.php
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
├── scripts/                 # Utility scripts
│   ├── install.sh           # Automated installation
│   └── uninstall.sh         # Clean uninstallation
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
- **Rule-based Detection**: Configurable rules for known fraud patterns (high-value, velocity, structuring)
- **Anomaly Detection**: Statistical and ML-based outlier detection
- **Network Analysis**: Entity relationship graphs for money laundering detection

### Machine Learning
- Feature engineering pipeline for transaction data
- Model training with cross-validation (XGBoost, Random Forest, Neural Networks)
- Automated model evaluation and registry
- Batch and real-time inference endpoints

### Analytics & Dashboards
- **Dashboard**: Real-time stats cards, 7-day transaction volume chart, recent transactions table
- **Transactions**: Filterable transaction list with date range, type, and status filters
- **Fraud Analytics**: Fraud rate trend charts, fraud type distribution, risk indicators, model performance comparison
- **Investigations**: Case management with status/priority tracking, assignee filters
- **Network Analysis**: Interactive network graph visualization, suspicious cluster detection, entity search

### Batch Processing
- Daily ETL pipelines via Airflow
- Feature store updates
- Model retraining schedules
- Report generation

## Getting Started

### Prerequisites
- Docker & Docker Compose v2+
- Google Cloud Project with BigQuery API enabled (for production)
- GCP Service Account with BigQuery permissions (for production)

### Quick Install (Recommended)

```bash
# Clone the repository
git clone <repository-url>
cd FinCrime_Data_Analysis

# Run automated installer
./install.sh
```

The installer will:
1. Check Docker/Docker Compose availability
2. Create `.env` from `.env.example`
3. Build Docker images
4. Start all services
5. Verify health checks
6. Print service URLs

### Manual Installation

1. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your GCP credentials and project settings
   ```

2. **Build and start services**
   ```bash
   docker compose build
   docker compose up -d
   ```

3. **Access services**
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
docker compose logs -f airflow-webserver
```

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/health` | Health check |
| GET | `/api/contract/fields` | List contract field definitions |
| GET | `/api/contract/required` | List required fields |
| GET | `/api/transactions` | List transactions |
| GET | `/api/analytics/summary` | Analytics summary |
| POST | `/api/detection/rules` | Run rule-based detection |
| GET | `/api/network/graph` | Network graph data |
| POST | `/api/models/train` | Trigger model training |
| GET | `/api/contract/mapping/{table_id}` | Get column mapping |
| PUT | `/api/contract/mapping/{table_id}` | Set column mapping |
| GET | `/api/contract/mapping/{table_id}/resolve` | Generate resolved SQL query |

## Frontend Pages

| Page | URL | Description |
|------|-----|-------------|
| Dashboard | http://localhost:8080/ | Stats, charts, recent transactions |
| Transactions | http://localhost:8080/transactions | Filterable transaction table |
| Fraud Analytics | http://localhost:8080/fraud-analytics | Fraud trends, risk indicators, models |
| Investigations | http://localhost:8080/investigations | Case management |
| Network Analysis | http://localhost:8080/network-analysis | Network graph, clusters, search |

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

## Scripts

### Install Script
```bash
./install.sh
```
Automated setup with health checks and service verification.

### Uninstall Script
```bash
./uninstall.sh
```
Interactive clean removal with confirmations for:
- Stopping services
- Removing Docker volumes
- Removing Docker images
- Removing `.env` file
- Docker system prune

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