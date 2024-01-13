<template>
    <AppLayoutVertical>
        <div>
            <v-sheet
              tile
              height="54"
              class="d-flex"
            >
              <v-select
                v-model="type"
                :items="types"
                dense
                variant="outlined"
                hide-details
                class="ma-2"
                label="View Mode"
              ></v-select>

              <v-select
                v-model="weekday"
                :items="weekdays"
                dense
                variant="outlined"
                hide-details
                label="weekdays"
                class="ma-2"
              ></v-select>

            </v-sheet>
            <v-sheet>
              <v-calendar
              :weekdays="weekView"
                ref="calendar"
                v-model="value"
                :view-mode="type"
                :events="events"
              ></v-calendar>
            </v-sheet>
          </div>
    </AppLayoutVertical>
</template>
<script>
import { VCalendar } from 'vuetify/labs/VCalendar'
import AppLayoutVertical from '@/Layouts/AppLayoutVertical.vue';
import { useDate } from 'vuetify';


export default {
    components: {
        VCalendar,
        AppLayoutVertical,
    },

data: () => ({
      type: 'month',
      types: ['month', 'week', 'day'],
      weekView: (this.weekdays) ? this.weekdays.split('.') : [1, 2, 3, 4, 5, 6, 0],
            value: [new Date()],
      events: [],
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      titles: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    }),
    mounted () {
      const adapter = useDate()
      this.getEvents({ start: adapter.startOfDay(adapter.startOfMonth(new Date())), end: adapter.endOfDay(adapter.endOfMonth(new Date())) })
    },
    methods: {
      getEvents ({ start, end }) {
        const events = []

        const min = start
        const max = end
        const days = (max.getTime() - min.getTime()) / 86400000
        const eventCount = this.rnd(days, days + 20)

        for (let i = 0; i < eventCount; i++) {
          const allDay = this.rnd(0, 3) === 0
          const firstTimestamp = this.rnd(min.getTime(), max.getTime())
          const first = new Date(firstTimestamp - (firstTimestamp % 900000))
          const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
          const second = new Date(first.getTime() + secondTimestamp)

          events.push({
            title: this.titles[this.rnd(0, this.titles.length - 1)],
            start: first,
            end: second,
            color: this.colors[this.rnd(0, this.colors.length - 1)],
            allDay: !allDay,
          })
        }

        this.events = events
      },
      getEventColor (event) {
        return event.color
      },
      rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
    },
  }
</script>
