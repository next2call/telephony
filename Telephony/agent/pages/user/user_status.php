<!-- Code goes here -->
<div class="user-status">
    <!-- back button with title -->
    <div class="back-with-title">
        <a href="./show_users.html"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <h5> User Status</h5>
    </div>

    <!-- form starts here -->
    <form action="">
        <div class="row my-card align-items-center">

            <!-- second input for user ID -->
            <div class="col-12 col-md-6 col-lg-4 select2-id-search-wrapper">
                <select class="select2-id-search" style="width: 100%">
                    <option>Option 1</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                    <option>Option 4</option>
                    <option>Option 5</option>
                </select>
            </div>

            <input type="submit" value="Submit">

        </div>
    </form>
    <div class="my-card-with-title">
        <div class="title-bar">
            <h4>User status for 1006-1006</h4>
            <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a>
        </div>
        <div class="card-body">
            <div class="my-secondary-table table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">USERNAME</th>
                        <th scope="col">GROUP</th>
                        <th scope="col">IP ADDRESS</th>
                        <th scope="col">SESSION</th>
                        <th scope="col">PHONE</th>
                        <th scope="col">CAMPAIGN</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">HANGUP TIME</th>
                        <th scope="col">CLOSER GROUP</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="9">No data available</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form action="" class="mt-5">
        <div class="row">
            <div class="my-dropdown-with-help col-12 col-md-6 col-lg-4">
                <div class="my-dropdown" style="width: 100%;">
                    <select style="width: 100%;" name="current_campaign" id="current_campaign" required>
                        <option></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                    <i class="fa fa-caret-down my-dropdown-arrow" aria-hidden="true"></i>
                    <label for="current_campaign">Current Campaigns</label>
                </div>
            </div>
            <input class="my-btn-primary" type="submit" value="Change">
        </div>
    </form>
    <div class="my-card-with-title">
        <div class="title-bar">
            <h4>Other info</h4>
            <a href="#"><i class="fa fa-download" aria-hidden="true"></i></a>
        </div>
        <div class="card-body">
            <div class="my-secondary-table table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ACTIVE CHAT</th>
                        <th scope="col">TIMECLOCK STATUS</th>
                        <th scope="col">LAST LOGOUT INFO</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="9">No data available</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row justify-content-end mb-5">
        <p class="my-4 col-12 text-right mr-5">
            <a href="#">User Multiple Day Status Detail Report</a>
        </p>
        <button class="my-btn-secondary mr-3">Timeclock Log In</button>
        <button class="my-btn-secondary mr-5" disabled>Emergency Log Out</button>
    </div>
</div>
<!-- Code goes here -->