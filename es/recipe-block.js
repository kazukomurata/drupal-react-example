import React from 'react';
//import ReactDOM from 'react-dom';
import RecipeList from './recipe-list';
import RecipeFilter from './recipe-filter';

export default class RecipeBlock extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      conditions : {},
    };
    this.handleFilterChange = this.handleFilterChange.bind(this);
  }

  handleFilterChange(filter) {
    let conditions = this.state.conditions;
    let values = conditions[filter.name] ? conditions[filter.name] : [];
    if (values.indexOf(filter.value) > -1) {
      values = values.filter(n => n !== filter.value);
    }
    else {
      values.push(filter.value);
    }
    if (values.length > 0) {
      conditions[filter.name] = values;
    }
    else {
      delete conditions[filter.name];
    }
    this.setState({
      conditions: conditions
    });
  }

  render() {
    return (
      <>
        <h2>Hello</h2>
        <RecipeFilter drupal={this.props.drupal} filters={this.props.filters} handleFilterChange={this.handleFilterChange}/>
        <div className={"grid--4"}>
          <RecipeList recipes={this.props.recipes} drupal={this.props.drupal} conditions={this.state.conditions}/>
        </div>
      </>
    );
  }
}

