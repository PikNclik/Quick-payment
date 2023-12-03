import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Router } from "@angular/router";
import { Observable, of, tap } from "rxjs";
import { User } from "src/app/models/data/user.model";
import { LoginResponse } from "src/app/models/responses/login.response";
import { DataService } from "./http/data.service";
import { ErrorService } from "./http/error.service";

@Injectable({ providedIn: 'root' })
export class AuthService extends DataService {
  constructor(
    httpClient: HttpClient,
  ) {
    super('', httpClient);
  }

  /**
   * store user object in local-storage
   * @param {User} user user object
   */
  private setUser(user?: User): void {
    if (!user) return;
    localStorage.setItem('user', JSON.stringify(user));
  }

  /**
   * remove user object from local-storage
   */
  public removeUser(): void {
    localStorage.removeItem('user');
    localStorage.removeItem('token');
  }

  /**
   * store jwt in local-storage
   * @param {string} token jwt
   */
  public setAuthToken(token?: string): void {
    localStorage.setItem("token", token || "");
  }

  /**
   * get user object from local-storage
   * @returns {User | null}
   */
  public getUser(): User | undefined {
    const user = localStorage.getItem("user");
    if (user) return JSON.parse(user) as User;
    return undefined;
  }

  /**
   * get jwt from local-storage
   * @returns {string} jwt
   */
  public getAuthToken(): string {
    return localStorage.getItem("token") || "";
  }

  /**
   * login by send credentials to server
   * @param credentials email and password
   * @returns {Observable<User>} login result
   */
  public login(credentials: { email: string, password: string }): Observable<LoginResponse> {
    return this.post<LoginResponse>('login', credentials).pipe(
      tap((response: LoginResponse) => {
        this.setUser(response.user);
        this.setAuthToken(response.user?.accessToken);
      }),
    );
  }

  /**
   * send logOut request to server and remove user & token from local-stroage
   */
  logOut(): Observable<void> {
    return this.post<any>('logout', '').pipe(tap(() => this.removeUser()));
  }

  /**
   * check if user is loggedIn
   * @returns {boolean}
   */
  isLoggedIn(): Observable<boolean> {
    const user = this.getUser();
    if (user) return of(true);
    return of(false);
  }
}
