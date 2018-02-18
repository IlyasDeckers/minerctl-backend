<template>
  <div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-content">
            <h4 class="card-title">Miner -
              <small class="category">Rigs</small>
            </h4>
            {{ claymore.response.pool }}
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <tr>
                    <th>GPU</th>
                    <th>Hashrate</th>
                    <th>Temperature</th>
                    <th>Fanspeed</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(gpu,index) in claymore.response.gpus">
                    <td>gpu{{ index }}</td>
                    <td>{{ gpu.hashrates }} MH/s</td>
                    <td>{{ gpu.temperature }} &#176;C</td>
                    <td>{{ gpu.fanSpeed }} %</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        claymore: {
          response: {
            pool: 'Loading',
            shares: {
              valid: '',
              rejected: ''
            },
            gpus: {}
          }
        },
        pusherKey: process.env.MIX_PUSHER_APP_KEY
      }
    },
    mounted() {
      this.pusher()
    },
    methods: {
      getStats() {

      },

      pusher() {
        Pusher.logToConsole = false;

        var pusher = new Pusher(this.pusherKey, {
          cluster: 'eu',
          encrypted: true
        })

        const channel = pusher.subscribe('minerctl_desktop');
        channel.bind('updateMinerStats_' + userId, (data) => {
          this.claymore = data
        })
      }
    }
  }
</script>
