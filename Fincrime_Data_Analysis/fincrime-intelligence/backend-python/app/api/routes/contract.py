from fastapi import APIRouter, HTTPException
from app.core.contract import (
    CONTRACT_FIELDS,
    REQUIRED_FIELDS,
    ColumnMapping,
    TableMapping,
    mapping_store,
)

router = APIRouter(prefix="/contract")


@router.get("/fields")
async def list_contract_fields():
    return [f.dict() for f in CONTRACT_FIELDS]


@router.get("/required")
async def required_fields():
    return REQUIRED_FIELDS


@router.get("/mapping/{table_id}")
async def get_mapping(table_id: str):
    mapping = mapping_store.get(table_id)
    if mapping is None:
        raise HTTPException(status_code=404, detail=f"No mapping for table {table_id}")
    return mapping.dict()


@router.put("/mapping/{table_id}")
async def set_mapping(table_id: str, mapping: TableMapping):
    return mapping_store.set(table_id, mapping).dict()


@router.get("/mapping/{table_id}/resolve")
async def resolve_mapping(table_id: str, limit: int = 100):
    from app.services.bigquery_service import BigQueryService

    service = BigQueryService()
    sql = service.resolve_select(table_id, limit)
    return {"table_id": table_id, "sql": sql}
