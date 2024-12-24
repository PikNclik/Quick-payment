import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { Merchant } from "src/app/models/data/merchant.model";
import { DataService } from "src/app/shared/services/http/data.service";

@Injectable()
export class MerchantService extends DataService {
  constructor(httpClient: HttpClient) {
    super('user', httpClient);
  }

  /**
   * block/un-block user
   *
   * @param {Merchant} user user
   * @returns {Observable<Merchant>}
   */
  public blockUser(user: Merchant): Observable<Merchant> {
    user.active = user.active == 0 ? 1 : 0;
    return this.post<Merchant>(`block/${user.id}`);
  }
}
