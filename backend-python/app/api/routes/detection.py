from fastapi import APIRouter

router = APIRouter()


@router.post("/rules")
async def run_rules():
    return {}
