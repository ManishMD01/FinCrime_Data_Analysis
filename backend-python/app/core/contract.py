from typing import Dict, List, Optional
from pydantic import BaseModel


class ContractField(BaseModel):
    name: str
    type: str
    purpose: str
    required: bool


CONTRACT_FIELDS: List[ContractField] = [
    ContractField(name="transaction_id", type="STRING", purpose="Unique event identifier", required=True),
    ContractField(name="account_id", type="STRING", purpose="Account involved", required=True),
    ContractField(name="counterparty_id", type="STRING", purpose="Related party, if available", required=False),
    ContractField(name="transaction_timestamp", type="TIMESTAMP", purpose="Event time", required=True),
    ContractField(name="amount", type="NUMERIC", purpose="Transaction amount", required=True),
    ContractField(name="currency", type="STRING", purpose="Currency code", required=True),
    ContractField(name="transaction_type", type="STRING", purpose="Transfer, deposit, withdrawal, etc.", required=True),
    ContractField(name="channel", type="STRING", purpose="Web, mobile, ATM, branch, etc.", required=True),
    ContractField(name="country_code", type="STRING", purpose="Country, where available", required=False),
    ContractField(name="fraud_label", type="INT64", purpose="Historical label, if available and trustworthy", required=False),
]

CONTRACT_FIELD_NAMES = [f.name for f in CONTRACT_FIELDS]
REQUIRED_FIELDS = [f.name for f in CONTRACT_FIELDS if f.required]


class ColumnMapping(BaseModel):
    source_column: Optional[str] = None


class TableMapping(BaseModel):
    table_id: str
    mappings: Dict[str, ColumnMapping] = {}


class MappingStore:
    def __init__(self) -> None:
        self._mappings: Dict[str, TableMapping] = {}

    def get(self, table_id: str) -> Optional[TableMapping]:
        return self._mappings.get(table_id)

    def set(self, table_id: str, mapping: TableMapping) -> TableMapping:
        mapping.table_id = table_id
        self._mappings[table_id] = mapping
        return mapping


mapping_store = MappingStore()
