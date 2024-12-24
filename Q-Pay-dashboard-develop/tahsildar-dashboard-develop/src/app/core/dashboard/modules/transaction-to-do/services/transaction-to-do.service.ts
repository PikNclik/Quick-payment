import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {DataService} from "src/app/shared/services/http/data.service";

const endPoint = 'transaction-to-do'

@Injectable()
export class TransactionToDoService extends DataService {
  constructor(httpClient: HttpClient) {
    super(endPoint, httpClient);
  }
}
