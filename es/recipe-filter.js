import React from 'react';
//import ReactDOM from 'react-dom';
import RecipeItem from './recipe-item';

export default class RecipeFilter extends React.Component {
  constructor(props) {
    super(props);
    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(e) {
    this.props.handleFilterChange(
      {
        name : 'field_difficulty',
        value : e.target.value
      });
  }

  render() {

    const difficulty = this.props.filters.difficulty;

    const options = difficulty.map((item) => {
      return (
        <label key={item.id} htmlFor={item.id}>
          {item.value}
        <input
          type="checkbox"
          id={item.id}
          value={item.id}
          onChange={this.handleChange}
        />
        </label>
      );

    })
    return (
      <div>
        {options}
      </div>
    );
  }
}
