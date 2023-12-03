import { Injectable } from '@angular/core';
import { Title } from "@angular/platform-browser";
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { filter, map } from "rxjs/operators";
import { environment } from 'src/environments/environment';
import { TranslationService } from './translation.service';

@Injectable({ providedIn: 'root' })
export class PageTitleService {
  constructor(
    private translationService: TranslationService,
    private activatedRoute: ActivatedRoute,
    private titleService: Title,
    private router: Router,
  ) {
    this.router.events.pipe(
      filter(event => event instanceof NavigationEnd),
      map(() => {
        let child = this.activatedRoute.firstChild;
        while (child) {
          if (child.firstChild) {
            child = child.firstChild;
          } else if (child.snapshot.data && child.snapshot.data['title']) {
            return child.snapshot.data['title'];
          } else {
            return null;
          }
        }
        return null;
      })
    ).subscribe((data: any) => {
      this.setTitle(data);
    });
  }

  setTitle(title?: string, prefix: string = environment.titlePrefix) {
    if (title) {
      this.translationService.translate.get(title).subscribe((string: any) => {
        this.titleService.setTitle(`${prefix} | ${string}`);
      })
    } else {
      this.titleService.setTitle(prefix);
    }
  }
}
