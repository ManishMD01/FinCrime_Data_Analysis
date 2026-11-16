#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="${SCRIPT_DIR}"

BLUE='\033[0;34m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log_info() { echo -e "${BLUE}[INFO]${NC} $*"; }
log_success() { echo -e "${GREEN}[SUCCESS]${NC} $*"; }
log_warn() { echo -e "${YELLOW}[WARN]${NC} $*"; }
log_error() { echo -e "${RED}[ERROR]${NC} $*"; }

check_requirements() {
    log_info "Checking requirements..."

    if ! command -v docker &> /dev/null; then
        log_error "Docker is not installed. Please install Docker first."
        exit 1
    fi

    if ! command -v docker compose &> /dev/null && ! command -v docker-compose &> /dev/null; then
        log_error "Docker Compose is not installed. Please install Docker Compose first."
        exit 1
    fi

    log_success "Requirements check passed"
}

setup_env() {
    log_info "Setting up environment..."

    if [[ ! -f "${PROJECT_ROOT}/.env" ]]; then
        if [[ -f "${PROJECT_ROOT}/.env.example" ]]; then
            cp "${PROJECT_ROOT}/.env.example" "${PROJECT_ROOT}/.env"
            log_warn "Created .env from .env.example. Please edit .env with your configuration."
        else
            log_error ".env.example not found"
            exit 1
        fi
    else
        log_info ".env already exists"
    fi
}

build_images() {
    log_info "Building Docker images..."

    cd "${PROJECT_ROOT}"
    docker compose build --pull

    log_success "Docker images built successfully"
}

start_services() {
    log_info "Starting services..."

    cd "${PROJECT_ROOT}"
    docker compose up -d

    log_success "Services started"
}

wait_for_health() {
    log_info "Waiting for services to be healthy..."

    local max_attempts=30
    local attempt=1

    while [[ $attempt -le $max_attempts ]]; do
        if curl -sf http://localhost:8000/health > /dev/null 2>&1; then
            log_success "Backend is healthy"
            break
        fi

        if [[ $attempt -eq $max_attempts ]]; then
            log_error "Backend health check failed after ${max_attempts} attempts"
            return 1
        fi

        sleep 2
        ((attempt++))
    done

    attempt=1
    while [[ $attempt -le $max_attempts ]]; do
        if curl -sf http://localhost:8080 > /dev/null 2>&1; then
            log_success "Frontend is healthy"
            break
        fi

        if [[ $attempt -eq $max_attempts ]]; then
            log_warn "Frontend health check timed out (may still be starting)"
            break
        fi

        sleep 2
        ((attempt++))
    done
}

print_summary() {
    echo
    log_success "Installation complete!"
    echo
    echo "Services:"
    echo "  Frontend:  http://localhost:8080"
    echo "  Backend:   http://localhost:8000"
    echo "  API Docs:  http://localhost:8000/docs"
    echo "  Health:    http://localhost:8000/health"
    echo
    echo "Next steps:"
    echo "  1. Edit .env with your GCP credentials"
    echo "  2. Restart services: docker compose restart"
    echo "  3. View logs: docker compose logs -f"
    echo
}

main() {
    echo "========================================"
    echo "  Fincrime Intelligence - Installer"
    echo "========================================"
    echo

    check_requirements
    setup_env
    build_images
    start_services
    wait_for_health
    print_summary
}

main "$@"