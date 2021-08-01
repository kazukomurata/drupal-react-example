import React from 'react';
//import ReactDOM from 'react-dom';
import RecipeList from './recipe-list';

export default class RecipeBlock extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <>
        <h2>Hello</h2>
        <div className={"grid--4"}>
          <RecipeList recipes={this.props.recipes}/>
        </div>
      </>
    );
  }
}

