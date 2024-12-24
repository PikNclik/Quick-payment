import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { DataService } from "src/app/shared/services/http/data.service";

const endPoint = 'working_day_holiday';

@Injectable()
export class WorkingDaysService extends DataService {
  constructor(httpClient: HttpClient) {
    super(endPoint, httpClient);
  }
}

