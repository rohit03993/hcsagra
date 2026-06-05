<nav class="school-quick-links" aria-label="Quick links">
    <div class="site-container">
        <ul class="school-quick-links__list">
            <li>
                <a href="{{ $settings->admissionUrl() }}" class="school-quick-links__item">
                    <span class="school-quick-links__icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824 2.998 12.078 12.078 0 01.665-6.479L12 14zm-4.106-6.31L12 5.251l4.106 2.439a12.08 12.08 0 00-4.212 4.212z"/></svg>
                    </span>
                    <span class="school-quick-links__label">Admission</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pages.show', $settings->mission_vision_page_slug ?: 'vision-mission') }}" class="school-quick-links__item">
                    <span class="school-quick-links__icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </span>
                    <span class="school-quick-links__label">Vision &amp; Mission</span>
                </a>
            </li>
            <li>
                <a href="{{ $settings->mandatoryDisclosureUrl() }}" class="school-quick-links__item">
                    <span class="school-quick-links__icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </span>
                    <span class="school-quick-links__label">Disclosure</span>
                </a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="school-quick-links__item">
                    <span class="school-quick-links__icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <span class="school-quick-links__label">Contact Us</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
