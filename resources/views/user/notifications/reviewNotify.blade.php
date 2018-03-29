 <li class="dd-note-list"> 
                              
                              <?php
                              $now = Carbon\Carbon::now('America/New_York');
                              $ends=$notifys->created_at;
                              $bn=$data['getNotification']->timeDifferences($ends,$now);
                              ?>

                              <span>{{$bn}}</span>
</li>