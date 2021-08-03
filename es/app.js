'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import RecipeBlock from './recipe-block';

(function (Drupal) {
  Drupal.behaviors.blockRecipeList = {
    attach(context, settings) {
      if (context === document) {
        const list = context.getElementById('recipe-list');
        const recipes = JSON.parse(settings.react_example.recipes)
        const filters = JSON.parse(settings.react_example.filters)
        ReactDOM.render(<RecipeBlock recipes={recipes} drupal={Drupal} filters={filters}/>, list);
        //ReactDOM.render(recipes , list);
      }
    }
  }
})(Drupal);
