import React from 'react';
//import ReactDOM from 'react-dom';
import RecipeItem from './recipe-item';

export default class RecipeList extends React.Component {
  constructor(props) {
    super(props);
  }
  render() {
    const rows = this.props.recipes.map((recipe) => {
      return (<RecipeItem recipe={recipe} key={recipe.id}/>);
      }
    )
    return (
      <div className={"view-content"}>
        {rows}
      </div>
    );
  }
}
