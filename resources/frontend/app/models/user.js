import Ember from 'ember';
import DS from 'ember-data';

export default DS.Model.extend({
  firstname: DS.attr(),
  lastname: DS.attr(),
  favorite_color: DS.attr(),
  connections: DS.attr(),

  // Concatenate first and last names into a full name
  fullName: Ember.computed('firstname', 'lastname', function() {
    return `${this.get('firstname')} ${this.get('lastname')}`;
  }),

  // Convert array of connections to an array of connection full names
  connectionNames: Ember.computed('connections', function() {
    let names = this.get('connections').map(connection => (
      `${connection.firstname} ${connection.lastname}`
    ));
    return names.join(', ');
  })
});
