 <li class="dd-note-list"> 
                              
                              <?php
                              $now = Carbon\Carbon::now('America/New_York');
                              $ends=$notifys->created_at;
                              $bn=$data['getNotification']->timeDifferences($ends,$now);
                              ?>
                              	<span class="dd-user">Pradnya Patil</span>
                              	<span> shared your photo.</span>
                              	<span> likes a post you shared.</span>
                              <span>{{$bn}}</span>
</li>