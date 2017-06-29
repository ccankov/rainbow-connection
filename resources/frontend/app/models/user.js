import Ember from 'ember';
import DS from 'ember-data';

export default DS.Model.extend({
  firstname: DS.attr(),
  lastname: DS.attr(),
  "favorite-color": DS.attr(),
  connections: DS.attr(),

  // Concatenate first and last names into a full name
  fullName: Ember.computed('firstname', 'lastname', function() {
    return `${this.get('firstname')} ${this.get('lastname')}`;
  }),

  // Compute text color for favorite color
  myColor: Ember.computed('favorite-color', function() {
    let color = this.get('favorite-color');
    return new Ember.String.htmlSafe("color: " + color);
  }),

  // Delete connection
  deleteConnection(connection_id) {
    const modelName = this.constructor.modelName;
    const adapter = this.store.adapterFor(modelName);
    return adapter.deleteConnection(parseInt(this.get('id')), connection_id);
  }
});
