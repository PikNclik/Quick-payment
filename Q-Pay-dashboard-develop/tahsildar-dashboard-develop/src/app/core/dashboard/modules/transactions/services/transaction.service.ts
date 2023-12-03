import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { Transaction } from "src/app/models/data/transaction.model";
import { DataService } from "src/app/shared/services/http/data.service";

const endPoint = 'payment'

@Injectable()
export class TransactionService extends DataService {
  constructor(httpClient: HttpClient) {
    super(endPoint, httpClient);
  }

  /**
   * cancel transaction
   *
   * @param {any} id transaction id
   * @returns {Observable<Transaction>}
   */
  public cancelTransaction(id: any): Observable<Transaction> {
    return this.post<Transaction>(`cancel/${id}`);
  }
}
