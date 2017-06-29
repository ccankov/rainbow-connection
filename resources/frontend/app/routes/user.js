import Ember from 'ember';

const colors = [
  'red', 'orangered', 'orange', 'moccasin', 'yellow', 'khaki',
  'green', 'teal', 'blue', 'mediumslateblue', 'purple', 'mediumvioletred'
];

export default Ember.Route.extend({
  model(params) {
    return this.get('store').queryRecord('user', params);
  },
  actions: {
    deleteConnection(connection_id) {
      this.currentModel.deleteConnection(connection_id).then((user) => {
        this.store.pushPayload('user', {
          "data": {
            "id": user.id,
            "type": 'user',
            "attributes": user
          }
        });
        this.refresh();
      });
    }
  }
});
