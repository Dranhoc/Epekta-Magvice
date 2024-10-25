<section class="s-partners bg-custom-grey text-primary">
  <div class="lg:d-grid container">

    <div class="col-span-4 col-start-2 flex flex-col justify-center">
      <h5>Ils nous font confiance</h5>
      <h4>Ils ont choisis Magvice pour protéger leurs infrastructures </h4>
    </div>

    <div class="relative z-[0] col-span-6 flex items-center">
      <div class="swiper swiper-logos">

        <div class="swiper-wrapper" data-anim="slide-right-multiple" data-offset="200">
          @for ($i = 0; $i < 4; $i++)
            <div class="swiper-slide">
              <a href="https://www.epekta.com" target="_blank">
                <div class="s-partner__visual">
                  @svg('frontoffice.sections.partners.placeholder1')
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="https://www.epekta.com" target="_blank">
                <div class="s-partner__visual">
                  @svg('frontoffice.sections.partners.placeholder2')
                </div>
              </a>
            </div>
          @endfor
        </div>
        <div class="swiper-pagination"></div>
      </div>

    </div>

  </div>
</section>
