from fastapi import FastAPI
from app.api.routes.contract import router as contract_router

app = FastAPI(title="Fincrime Intelligence Backend")

app.include_router(contract_router)


@app.get("/health")
async def health():
    return {"status": "ok"}
