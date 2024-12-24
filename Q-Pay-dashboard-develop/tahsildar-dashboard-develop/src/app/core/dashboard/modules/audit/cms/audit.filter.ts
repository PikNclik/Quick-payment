import { ngSelectAdminConfig } from "src/app/models/data/admin.model";
import { ngSelectBankConfig } from "src/app/models/data/bank.model";
import { ngSelectCityConfig } from "src/app/models/data/city.model";
import { ngSelectMerchantConfig } from "src/app/models/data/merchant.model";
import {transactionStatus, transactionType} from "src/app/models/data/transaction.model";
import { FilterInputType, FilterSchema, FilterSelectOption } from "src/app/shared/components/cms/filters/config/filter.iterface";

export let auditFilterSchema: FilterSchema = {
  inputs: [
    {
      key: 'user_id',
      label: 'user',
      inputType: FilterInputType.ng_select,
      ngSelectConfig: ngSelectAdminConfig,
    },
    {
      key: 'model',
      label: 'type',
      inputType: FilterInputType.select,
      options: [
        { value: "merchant", label: "merchant" },
        { value: "transaction_to_do", label: "transaction_to_do" },
        { value: "terminal_bank", label: "terminal_bank" },
        { value: "setting", label: "setting" },
        { value: "working_days", label: "working_days" },
        { value: "bank", label: "bank" },
        { value: "commission", label: "commission" },
      ],
    },
    {
      key: 'id',
      label: 'id',
      inputType: FilterInputType.number
    }
  ],
}
