from fastapi import APIRouter

router = APIRouter()


@router.get("/graph")
async def network_graph():
    return {}
