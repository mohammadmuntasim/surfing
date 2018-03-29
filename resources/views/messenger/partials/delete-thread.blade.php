<style type="text/css">
  div#delete-thread-confirm-dialog {
    height: auto !important;
    background: transparent;
    box-shadow: none !important;
    border: 0px;
    width: 630px;
    
  }
  div#delete-thread-confirm-dialog .modal-dialog {
    left: -10px;
  }

</style>
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#delete-thread-confirm-dialog" id="delete-thread-btn-pop-up">Open Modal</button> -->
<!-- Modal -->
<div id="delete-thread-confirm-dialog" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title">Delete This Entire Conversation?</h4>
      </div>
      <div class="modal-body">
        <p>Once you delete your copy of this conversation, it cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="confirmDeleteConversation()">Delete Conversation</button>
      </div>
    </div>
  </div>
</div>