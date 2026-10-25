from fastapi import APIRouter

router = APIRouter()


@router.post("/train")
async def train_model():
    return {}
