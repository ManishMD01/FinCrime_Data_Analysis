from pydantic import BaseSettings


class Settings(BaseSettings):
    project_id: str
    dataset: str = "fincrime"

    class Config:
        env_file = ".env"


settings = Settings()
