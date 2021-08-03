(function (Drupal) {
  Drupal.behaviors.reactExampleTranslation = {
    attach(context, settings) {
      if (context === document) {
        Drupal.t("View Recipe");
      }
    }
  }
})(Drupal);
