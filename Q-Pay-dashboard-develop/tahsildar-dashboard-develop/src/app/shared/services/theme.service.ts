import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ThemeService {
  /**
    * emitter when theme changed by user
    */
  public themeChange$: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(localStorage.getItem('dark_theme') == 'true' || false);

  /**
   * Change app Theme Dark/Light
   *
   * @param {boolean} theme pass `true` for darkTheme or `false` for lightTheme.
   */
  public switchTheme(theme: boolean) {
    localStorage.setItem('dark_theme', theme.toString());
    this.themeChange$.next(theme);
  }
}
