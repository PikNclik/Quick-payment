import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { DataService } from "src/app/shared/services/http/data.service";

const endPoint = 'statistics';

@Injectable()
export class StatisticsService extends DataService {
  constructor(httpClient: HttpClient) {
    super(endPoint, httpClient);
  }
}
