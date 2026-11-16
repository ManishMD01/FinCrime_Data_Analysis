from pydantic_settings import BaseSettings


class Settings(BaseSettings):
    project_id: str = ""
    dataset: str = "fincrime"
    backend_host: str = "0.0.0.0"
    backend_port: int = 8000

    class Config:
        env_file = ".env"
        extra = "ignore"


settings = Settings()
