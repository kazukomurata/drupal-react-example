import React from 'react';
//import ReactDOM from 'react-dom';

export default class RecipeItem extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    const recipe = this.props.recipe;
    const linkname = Drupal.t("View Recipe");
    return (
      <div className={"views-row"}>
        <article className={"view-mode-card node"}>
          <h2 className="node__title">
            {recipe.title}
          </h2>
          <div className={"node__content"}>
            <div className={"label-items field field--label-inline"}>
              <div className={"field__label"}>Difficulty</div>
              <div className={"field__item"}>{recipe.field_difficulty}</div>
            </div>
          </div>
          <div className="read-more">
            <a className="read-more__link" href={recipe.url}>
              {linkname}
            </a>
          </div>
        </article>
      </div>
    );
  }
}
