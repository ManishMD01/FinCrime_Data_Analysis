SECRET_KEY = "change-me"


def verify_token(token: str) -> bool:
    return token == SECRET_KEY
