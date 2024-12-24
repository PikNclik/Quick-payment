import { Injectable } from '@angular/core';
import { Transaction } from 'src/app/models/data/transaction.model';
import {
  BaseCmsAction,
  BaseCmsConfig,
  CellType,
} from 'src/app/shared/components/cms/config/cms.config';
import { CmsService } from 'src/app/shared/components/cms/services/cms.service';
import { auditFilterSchema } from './audit.filter';
import { HttpService } from 'src/app/shared/services/http/http.service';
import { Audit } from 'src/app/models/data/audit.model';

@Injectable()
export class AuditCmsService extends CmsService<Transaction> {

  constructor(
    httpService: HttpService,
  ) {
    super(httpService);
  }

  cmsConfig: BaseCmsConfig<Audit> = {
    endPoint: 'audit',
    columns: [
      { key: 'aud_type', name: 'type' },
      { key: 'auditable_id', name: 'id' },
      { key: 'user_name', name: 'doer' },
      { key: 'event', name: 'event' },
      // { key: 'old_values', name: 'old_values' },
      // { key: 'new_values', name: 'new_values' },
      { key: 'created_at', name: 'created_at' },

    ],
    actions: [
      // {
      //   action: BaseCmsAction.details,
      //   label: "View",
      //   color: 'accent',
      // }
    ],
    exportable: false,
    exportName: 'Audit',
  };

  override filterSchema = auditFilterSchema;
}
