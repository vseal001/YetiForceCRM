<!-- /* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */ -->
<template>
  <q-header class="bg-grey-10">
    <q-bar>
      <div class="flex items-center no-wrap full-width justify-between js-drag">
        <div class="flex no-wrap">
          <q-btn dense flat round :color="leftPanel ? 'info' : ''" @click="toggleLeftPanel()">
            <icon icon="yfi-menu-group-room" />
            <q-tooltip>{{ translate('JS_CHAT_ROOMS_MENU') }}</q-tooltip>
          </q-btn>
          <q-btn @click="toggleEnter()" dense round flat :color="sendByEnter ? 'info' : ''">
            <icon :icon="sendByEnter ? 'yfi-enter-on' : 'yfi-enter-off'" />
            <q-tooltip>{{ translate('JS_CHAT_ENTER') }}</q-tooltip>
          </q-btn>
          <notify-btn />
          <q-btn
            @click="toggleSoundNotification()"
            dense
            round
            flat
            :icon="isSoundNotification ? 'mdi-volume-high' : 'mdi-volume-off'"
            :color="isSoundNotification ? 'info' : ''"
          >
            <q-tooltip>{{ translate(isSoundNotification ? 'JS_CHAT_SOUND_ON' : 'JS_CHAT_SOUND_OFF') }}</q-tooltip>
          </q-btn>
        </div>
        <q-tabs
          @input="toggleRoomTimer"
          v-model="tab"
          class="chat-tabs"
          dense
          shrink
          inline-label
          narrow-indicator
          indicator-color="info"
          active-color="info"
        >
          <q-tab name="chat" :style="{ 'min-width': '40px' }">
            <icon class="q-icon q-tab__icon" size="20px" icon="yfi-branding-chat" />
            <span class="q-tab__label">{{ isSmall ? '' : translate('JS_CHAT') }}</span>
            <q-tooltip>{{ translate('JS_CHAT_DESC') }}</q-tooltip>
          </q-tab>
          <q-tab name="unread">
            <icon class="q-icon q-tab__icon" size="20px" icon="yfi-unread-messages" />
            <span class="q-tab__label">{{ isSmall ? '' : translate('JS_CHAT_UNREAD') }}</span>
            <q-tooltip>{{ translate('JS_CHAT_UNREAD_DESC') }}</q-tooltip>
          </q-tab>
          <q-tab name="history" icon="mdi-history" :label="isSmall ? '' : translate('JS_CHAT_HISTORY')">
            <q-tooltip>{{ translate('JS_CHAT_HISTORY_DESC') }}</q-tooltip>
          </q-tab>
        </q-tabs>
        <div class="flex no-wrap">
          <template v-if="$q.platform.is.desktop">
            <btn-grab v-show="miniMode" class="text-white flex flex-center" grabClass="js-drag" size="19px" />
            <q-btn dense flat round :icon="miniMode ? 'mdi-window-maximize' : 'mdi-window-restore'" @click="toggleSize()">
              <q-tooltip>{{ miniMode ? translate('JS_MAXIMIZE') : translate('JS_MINIMIZE') }}</q-tooltip>
            </q-btn>
          </template>
          <q-btn dense flat round icon="mdi-close" @click="setDialog(false)">
            <q-tooltip>{{ translate('JS_CLOSE') }}</q-tooltip>
          </q-btn>
          <q-btn dense flat round :color="rightPanel ? 'info' : ''" @click="toggleRightPanel()">
            <icon icon="yfi-menu-entrant" />
            <q-tooltip>{{ translate('JS_CHAT_PARTICIPANTS_MENU') }}</q-tooltip>
          </q-btn>
        </div>
      </div>
    </q-bar>
  </q-header>
</template>
<script>
import NotifyBtn from './NotifyBtn.vue'
import BtnGrab from 'components/BtnGrab.vue'
import { createNamespacedHelpers } from 'vuex'
const { mapActions, mapMutations, mapGetters } = createNamespacedHelpers('Chat')

export default {
  name: 'ChatHeader',
  components: { NotifyBtn, BtnGrab },
  props: {
    inputSearchVisible: { type: Boolean, required: false },
    tabHistoryShow: { type: Boolean, required: false },
    right: { type: Boolean, required: false },
    left: { type: Boolean, required: false }
  },
  data() {
    return {
      moduleName: 'Chat',
      timerRoom: false
    }
  },
  computed: {
    ...mapGetters(['config', 'isSoundNotification', 'sendByEnter', 'leftPanel', 'rightPanel']),
    miniMode: {
      get() {
        return this.$store.getters['Chat/miniMode']
      },
      set(isMini) {
        this.maximize(isMini)
      }
    },
    tab: {
      get() {
        return this.$store.getters['Chat/tab']
      },
      set(tab) {
        this.$store.commit('Chat/setTab', tab)
      }
    },
    isSmall() {
      return this.miniMode || !this.$q.platform.is.desktop
    }
  },
  methods: {
    ...mapActions(['toggleRightPanel', 'toggleLeftPanel', 'maximize']),
    ...mapMutations([
      'setDialog',
      'setLeftPanel',
      'setRightPanel',
      'setSendByEnter',
      'setSoundNotification',
      'updateRooms'
    ]),
    showTabHistory: function(value) {
      this.$emit('showTabHistory', value)
    },
    toggleRoomTimer(tabName) {
      if (tabName === 'chat' && this.timerRoom) {
        clearTimeout(this.timerRoom)
        this.timerRoom = false
      } else if (!this.timerRoom) {
        this.initTimer()
      }
    },
    initTimer() {
      this.timerRoom = setTimeout(() => {
        AppConnector.request({
          module: 'Chat',
          action: 'ChatAjax',
          mode: 'getRooms'
        }).done(({ result }) => {
          this.updateRooms(result.roomList)
          this.initTimer()
        })
      }, this.config.refreshRoomTime)
    },
    toggleSize() {
      if (!this.miniMode) {
        this.miniMode = true
        this.setLeftPanel(false)
        this.setRightPanel(false)
      } else {
        this.miniMode = false
      }
    },
    toggleEnter() {
      this.setSendByEnter(!this.sendByEnter)
    },
    toggleSoundNotification() {
      this.setSoundNotification(!this.isSoundNotification)
    }
  },
  beforeDestroy() {
    clearTimeout(this.timerRoom)
  }
}
</script>
<style lang="sass">
.chat-tabs
	.q-tab__content
		min-width: 40px
</style>
