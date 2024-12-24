import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { DataService } from "src/app/shared/services/http/data.service";

@Injectable()
export class CommissionService extends DataService {
  constructor(httpClient: HttpClient) {
    super('commission', httpClient);
  }

}
