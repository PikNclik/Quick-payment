export interface Statistics {
  merchants?: Merchants;
  transactions?: Transactions;
}

interface Merchants {
  total_merchants?: number;
  total_active_merchants?: number;
}

interface Transactions {
  total_transactions?: number;
  pending_value?: number;
  paid_value?: number;
}
