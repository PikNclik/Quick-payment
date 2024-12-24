import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { DataService } from "src/app/shared/services/http/data.service";

@Injectable()
export class SettingsService extends DataService {
  constructor(httpClient: HttpClient) {
    super('setting', httpClient);
  }
}
