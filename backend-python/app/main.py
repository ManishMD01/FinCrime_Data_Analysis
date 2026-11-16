from fastapi import FastAPI
from app.api.routes.contract import router as contract_router
from app.api.routes.transactions import router as transactions_router
from app.api.routes.detection import router as detection_router
from app.api.routes.analytics import router as analytics_router
from app.api.routes.network import router as network_router
from app.api.routes.models import router as models_router

app = FastAPI(title="Fincrime Intelligence Backend")

app.include_router(contract_router, prefix="/api")
app.include_router(transactions_router, prefix="/api")
app.include_router(detection_router, prefix="/api")
app.include_router(analytics_router, prefix="/api")
app.include_router(network_router, prefix="/api")
app.include_router(models_router, prefix="/api")


@app.get("/health")
async def health():
    return {"status": "ok"}
