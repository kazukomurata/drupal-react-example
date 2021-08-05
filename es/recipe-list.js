import React from 'react';
//import ReactDOM from 'react-dom';
import RecipeItem from './recipe-item';

export default class RecipeList extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    const conditions = this.props.conditions;

    const rows = this.props.recipes.map((recipe) => {
        let show = false;

        if (Object.keys(conditions).length > 0) {
          for (const field_name in conditions) {
            if (conditions.hasOwnProperty(field_name)){
              conditions[field_name].forEach((value) => {
                if (recipe[field_name] === value) {
                  show = true;
                }
              });
            }
          }
        }
        else {
          show = true;
        }
        if (show === true) {
          return (<RecipeItem recipe={recipe} key={recipe.id}
                              drupal={this.props.drupal}/>);
        }
      }
    )
    return (
      <div className={"view-content"}>
          {rows}
      </div>
    );
  }
}
