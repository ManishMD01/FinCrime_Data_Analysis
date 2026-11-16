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

confirm() {
    local prompt="${1:-Are you sure?}"
    local response
    read -rp "${prompt} [y/N]: " response
    [[ "$response" =~ ^[Yy]$ ]]
}

stop_services() {
    log_info "Stopping services..."

    cd "${PROJECT_ROOT}"
    if docker compose ps -q | grep -q .; then
        docker compose down
        log_success "Services stopped"
    else
        log_info "No running services found"
    fi
}

remove_volumes() {
    if confirm "Remove Docker volumes (this will delete all data)?"; then
        log_info "Removing volumes..."
        cd "${PROJECT_ROOT}"
        docker compose down -v
        log_success "Volumes removed"
    else
        log_info "Volumes preserved"
    fi
}

remove_images() {
    if confirm "Remove Docker images built for this project?"; then
        log_info "Removing images..."

        local images=(
            "fincrime-backend-python"
            "fincrime-frontend-php"
        )

        for img in "${images[@]}"; do
            if docker images -q "${img}" | grep -q .; then
                docker rmi "${img}" 2>/dev/null || true
                log_info "Removed image: ${img}"
            fi
        done

        log_success "Images removed"
    else
        log_info "Images preserved"
    fi
}

remove_env() {
    if confirm "Remove .env file?"; then
        if [[ -f "${PROJECT_ROOT}/.env" ]]; then
            rm "${PROJECT_ROOT}/.env"
            log_success ".env file removed"
        else
            log_info ".env file not found"
        fi
    else
        log_info ".env file preserved"
    fi
}

clean_docker() {
    if confirm "Run docker system prune to clean up unused resources?"; then
        log_info "Cleaning up Docker system..."
        docker system prune -f
        log_success "Docker system cleaned"
    fi
}

main() {
    echo "========================================"
    echo "  Fincrime Intelligence - Uninstaller"
    echo "========================================"
    echo

    if ! confirm "This will uninstall Fincrime Intelligence. Continue?"; then
        log_info "Uninstall cancelled"
        exit 0
    fi

    stop_services
    remove_volumes
    remove_images
    remove_env
    clean_docker

    echo
    log_success "Uninstall complete!"
    echo
    echo "Note: Source code and git history are preserved."
    echo "To completely remove, delete the project directory:"
    echo "  rm -rf ${PROJECT_ROOT}"
}

main "$@"