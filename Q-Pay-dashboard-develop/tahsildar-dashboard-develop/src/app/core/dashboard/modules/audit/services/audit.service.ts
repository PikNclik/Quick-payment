import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { DataService } from "src/app/shared/services/http/data.service";

const endPoint = 'audit'

@Injectable()
export class AuditService extends DataService {
  constructor(httpClient: HttpClient) {
    super(endPoint, httpClient);
  }

  
}
