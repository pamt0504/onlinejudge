function StringToDate(s) {
    var d = new Date();
    d.setYear(parseInt(s.substring(0, 4), 10));
    d.setMonth(parseInt(s.substring(5, 7) - 1, 10));
    d.setDate(parseInt(s.substring(8, 10), 10));
    d.setHours(parseInt(s.substring(11, 13), 10));
    d.setMinutes(parseInt(s.substring(14, 16), 10));
    d.setSeconds(parseInt(s.substring(17, 19), 10));
    return d;
}

function Submit(submitId, teamId, alphabetId, subTime, resultId) {
    this.submitId = submitId; 
    this.teamId = teamId; 
    this.alphabetId = alphabetId; 
    this.subTime = new Date(subTime);
    this.resultId = resultId;
}

function TeamProblem() {
    this.alphabetId = "";
    this.isAccepted = false;
    this.penalty = 0; 
    this.acceptedTime = new Date(); 
    this.submitCount = 0; 
    this.compileErrorCount = 0; 
    this.isUnkonwn = false; 
}

function Team(teamId, teamName, teamMember, official) {
    this.teamId = teamId; 
    this.teamName = teamName; 
    this.teamMember = teamMember; 
    this.official = true; 
    this.solved = 0; 
    this.penalty = 0; 
    this.gender = false; 
    this.submitProblemList = []; 
    this.unkonwnAlphabetIdMap = new Array(); 
    this.submitList = [];
    this.lastRank = 0; 
    this.nowRank = 0; 
}

Team.prototype.init = function(startTime, freezeBoardTime) {
    
    this.submitList.sort(function(a, b) {
        return a.submitId - b.submitId;
    });
    for (var key in this.submitList) {
        var sub = this.submitList[key];
     
        var p = this.submitProblemList[sub.alphabetId];
        if (!p) p = new TeamProblem();
    
        p.alphabetId = sub.alphabetId;
      
        if (p.isAccepted) continue;
        if (sub.subTime > freezeBoardTime) {
            p.isUnkonwn = true;
            this.unkonwnAlphabetIdMap[p.alphabetId] = true;
        }
        p.submitCount++;
        p.isAccepted = (sub.resultId == 4);
  
        if (sub.resultId == 11) {
            p.compileErrorCount++;
        }

        if (p.isAccepted) {
 
            p.acceptedTime = sub.subTime.getTime() - startTime.getTime();

            if (p.acceptedTime < freezeBoardTime - startTime) {
                p.penalty += p.acceptedTime + (p.submitCount - p.compileErrorCount - 1) * 20 * 60 * 1000;
                this.solved++;
                this.penalty += p.penalty;
            }
        }

        this.submitProblemList[p.alphabetId] = p;
    }
}

Team.prototype.countUnkonwnProblme = function() {
    var count = 0;
    for (var key in this.unkonwnAlphabetIdMap) {
        count++;
    }
    return count;
}

Team.prototype.updateOneProblem = function() {
    for (var key in this.submitProblemList) {
        var subProblem = this.submitProblemList[key];
       
        if (subProblem.isUnkonwn) {
            
            subProblem.isUnkonwn = false;
            delete this.unkonwnAlphabetIdMap[subProblem.alphabetId];
            
            if (subProblem.isAccepted) {
                subProblem.penalty += subProblem.acceptedTime + (subProblem.submitCount - subProblem.compileErrorCount - 1) * 20 * 60 * 1000;
                this.solved++;
                this.penalty += subProblem.penalty;
                return true;
            }
            return false;
        }
    }
}

function TeamCompare(a, b) {
    if (a.solved != b.solved) 
        return a.solved > b.solved ? -1 : 1;
    if (a.penalty != b.penalty) 
        return a.penalty < b.penalty ? -1 : 1;
    return a.teamId.localeCompare(b.teamId);
}

function Board(problemCount, medalCounts, startTime, freezeBoardTime) {
    this.problemCount = problemCount; 
    this.medalCounts = medalCounts;
    this.medalRanks = []; 
    this.medalStr = ["gold", "silver", "bronze"];
    this.problemList = []; 
    this.startTime = startTime;
    this.freezeBoardTime = freezeBoardTime;
    this.teamList = []; 
    this.submitList = []; 
    this.teamNowSequence = []; 
    this.teamNextSequence = []; 
    this.teamCount = 0; 
    this.displayTeamPos = 0; 
    this.noAnimate = true; 

    var ACode = 65;
    for (var i = 0; i < problemCount; i++)
        this.problemList.push(String.fromCharCode(ACode + i));

    this.medalRanks[0] = medalCounts[0];
    for (var i = 1; i < this.medalCounts.length; ++i) {
        this.medalRanks[i] = this.medalCounts[i] + this.medalRanks[i - 1];
    }

    this.submitList = getSubmitList();
    this.teamList = getTeamList();

    for (var key in this.submitList) {
        var sub = this.submitList[key];
        this.teamList[sub.teamId].submitList.push(sub);
    }

    for (var key in this.teamList) {
        var team = this.teamList[key];
        team.init(this.startTime, this.freezeBoardTime);
        this.teamNowSequence.push(team);
        this.teamCount++;
    }
    this.displayTeamPos = this.teamCount - 1;

    this.teamNowSequence.sort(function(a, b) {
        return TeamCompare(a, b);
    });
    this.teamNextSequence = this.teamNowSequence.slice(0);

}

Board.prototype.updateTeamSequence = function() {
    var teamSequence = this.teamNextSequence.slice(0); //复制数组，js为引用传递
    teamSequence.sort(function(a, b) {
        return TeamCompare(a, b);
    });

    var toPos = -1;
    for (var i = 0; i < this.teamCount; i++) {
        if (this.teamNextSequence[i].teamId != teamSequence[i].teamId) {
            toPos = i;
            break;
        }
    }

    this.teamNowSequence = this.teamNextSequence.slice(0);
    this.teamNextSequence = teamSequence.slice(0);

    return toPos;
}

Board.prototype.UpdateOneTeam = function() {
    var updateTeamPos = this.teamCount - 1;
    while (updateTeamPos >= 0 && this.teamNextSequence[updateTeamPos].countUnkonwnProblme() < 1)
        updateTeamPos--;
    if (updateTeamPos >= 0) {
        while (this.teamNextSequence[updateTeamPos].countUnkonwnProblme() > 0) {
            var result = this.teamNextSequence[updateTeamPos].updateOneProblem();
            return this.teamNextSequence[updateTeamPos];
        }
    }
    return null;
}

Board.prototype.showInitBoard = function() {

    var rankPer = 5; 
    var teamPer = 25;
    var solvedPer = 4; 
    var penaltyPer = 7; 
    var problemStatusPer = (100.0 - rankPer - teamPer - solvedPer - penaltyPer) / this.problemCount;

    var headHTML =
        "<div id=\"timer\"></div>\
        <div class=\"ranktable-head\">\
            <table class=\"table\">\
                <tr>\
                    <th width=\"" + rankPer + "%\">Rank</th>\
                    <th width=\"" + teamPer + "%\">Team</th>\
                    <th width=\"" + solvedPer + "%\">Solved</th>\
                    <th width=\"" + penaltyPer + "%\">Penalty</th>";
    var footHTML =
        "</tr>\
            </table>\
        </div>";
    $('body').append(headHTML + footHTML);

    for (var i = 0; i < this.problemList.length; i++) {
        var alphabetId = this.problemList[i];
        var bodyHTML = "<th width=\"" + problemStatusPer + "%\">" + alphabetId + "</th>";
        $('.ranktable-head tr').append(bodyHTML);
    }

    var maxRank = 0;

    for (var i = 0; i < this.teamCount; i++) {

        var team = this.teamNowSequence[i];

        var rank = 0;
        var medal = -1;
        if (team.solved != 0) {
            rank = i + 1;
            maxRank = rank + 1;
            for (var j = this.medalRanks.length - 1; j >= 0; j--) {
                if (rank <= this.medalRanks[j])
                    medal = j;
            }
        } else {
            rank = maxRank;
            medal = -1;
        }

        var headHTML =
            "<div id=\"team_" + team.teamId + "\" class=\"team-item\" team-id=\"" + team.teamId + "\"> \
                    <table class=\"table\"> \
                        <tr>";
        var rankHTML = "<th class=\"rank\" width=\"" + rankPer + "%\">" + rank + "</th>";
        var teamHTML = "<td class=\"team-name\" width=\"" + teamPer + "%\"><span>" + team.teamName + /*"<br/>" + team.teamMember +*/ "</span></td>";
        var solvedHTML = "<td class=\"solved\" width=\"" + solvedPer + "%\">" + team.solved + "</td>";
        var penaltyHTML = "<td class=\"penalty\" width=\"" + penaltyPer + "%\">" + parseInt(team.penalty / 1000.0 / 60.0) + "</td>";
        var problemHTML = "";
        for (var key in this.problemList) {
            problemHTML += "<td class=\"problem-status\" width=\"" + problemStatusPer + "%\" alphabet-id=\"" + this.problemList[key] + "\">";
            var tProblem = team.submitProblemList[this.problemList[key]];
            if (tProblem) {
                if (tProblem.isUnkonwn)
                    problemHTML += "<span class=\"label label-warning\">" + tProblem.submitCount + "</span></td>";
                else {
                    if (tProblem.isAccepted) {
                        problemHTML += "<span class=\"label label-success\">" + tProblem.submitCount + "/" + parseInt(tProblem.acceptedTime / 1000.0 / 60.0) + "</span></td>";
                    } else {
                        problemHTML += "<span class=\"label label-danger\">" + tProblem.submitCount + "</span></td>";
                    }
                }
            }
        }
        var footHTML =
            "</tr> \
                        </table> \
                    </div>";

        var HTML = headHTML + rankHTML + teamHTML + solvedHTML + penaltyHTML + problemHTML + footHTML;

        $('body').append(HTML);

        if (medal != -1)
            $("#team_" + team.teamId).addClass(this.medalStr[medal]);

    }

    var headHTML =
        "<div id=\"team-void\" class=\"team-item\"> \
                    <table class=\"table\"> \
                        <tr>";
    var rankHTML = "<th class=\"rank\" width=\"" + rankPer + "%\"></th>";
    var teamHTML = "<td class=\"team-name\" width=\"" + teamPer + "%\"></td>";
    var solvedHTML = "<td class=\"solved\" width=\"" + solvedPer + "%\"></td>";
    var penaltyHTML = "<td class=\"penalty\" width=\"" + penaltyPer + "%\"></td>";
    var problemHTML = "";
    for (var key in this.problemList) {
        problemHTML += "<td class=\"problem-status\" width=\"" + problemStatusPer + "%\" alphabet-id=\"" + this.problemList[key] + "\"></td>";
    }
    var footHTML =
        "</tr> \
                        </table> \
                    </div>";

    var HTML = headHTML + rankHTML + teamHTML + solvedHTML + penaltyHTML + problemHTML + footHTML;

    $('body').append(HTML);

    var headerHeight = 44;
    var teamHeight = 68; 
    for (var i = 0; i < this.teamCount; ++i) {
        var teamId = this.teamNowSequence[i].teamId;
        $("div[team-id=\"" + teamId + "\"]").stop().animate({ top: i * teamHeight + headerHeight }, 300);
    }
    $("#team-void").stop().animate({ top: this.teamCount * teamHeight + headerHeight }, 300);
}

Board.prototype.updateTeamStatus = function(team) {
    var thisBoard = this;

    for (var key in team.submitProblemList) {
        var tProblem = team.submitProblemList[key];

        problemHTML = "";
        if (tProblem.isUnkonwn)
            problemHTML = "<span class=\"label label-warning\">" + tProblem.submitCount + "</td>";
        else {
            if (tProblem.isAccepted) {
                problemHTML = "<span class=\"label label-success\">" + tProblem.submitCount + "/" + parseInt(tProblem.acceptedTime / 1000.0 / 60.0) + "</td>";
            } else {
                problemHTML = "<span class=\"label label-danger\">" + tProblem.submitCount + "</td>";
            }
        }


        var $problemStatus = $("#team_" + team.teamId + " .problem-status[alphabet-id=\"" + key + "\"]");
        var $statusSpan = $problemStatus.children('span[class="label label-warning"]');

        if (tProblem.isUnkonwn == false) {

            $('.team-item.hold').removeClass("hold");
            var $team = $("div[team-id=\"" + team.teamId + "\"]");

            $team.addClass("hold");

            var clientHeight = document.documentElement.clientHeight || document.body.clientHeight || 0;
            var teamTopHeight = $team.offset().top - clientHeight + 100;

            $('body,html').stop().animate({
                    scrollTop: teamTopHeight
                },
                500);

            (function(thisBoard, tProblem, problemHTML) {

                var speed = 400; 
                $statusSpan.fadeOut(speed).fadeIn(speed).fadeOut(speed).fadeIn(speed, function() {
                  
                    $(this).parent().html(problemHTML);
                });
            })(thisBoard, tProblem, problemHTML);
        }
    }

    (function(thisBoard, team) {

        $('#timer').animate({ margin: 0 }, 1600, function() {

            var maxRank = 0;

            for (var i in thisBoard.medalStr) {
                $(".team-item").removeClass(thisBoard.medalStr[i]);
            }

            for (var i = 0; i < thisBoard.teamCount; i++) {
                var t = thisBoard.teamNextSequence[i];
                var medal = -1;
                var rankValue = 0;
                if (t.solved != 0) {
                    rankValue = i + 1;
                    maxRank = rankValue + 1;
                    for (var j = thisBoard.medalRanks.length - 1; j >= 0; j--) {
                        if (rankValue <= thisBoard.medalRanks[j])
                            medal = j;
                    }
                } else {
                    rankValue = maxRank;
                    medal = -1;
                }

                $team = $("div[team-id=\"" + t.teamId + "\"]");

                if (medal != -1)
                    $team.addClass(thisBoard.medalStr[medal]);

                $("#team_" + t.teamId + " .rank").html(rankValue);

            }

            $("#team_" + team.teamId + " .solved").html(team.solved);

            $("#team_" + team.teamId + " .penalty").html(parseInt(team.penalty / 1000.0 / 60.0));
        }, false);

    })(thisBoard, team);

}

Board.prototype.moveTeam = function(toPos) {
    var thisBoard = this;
    (function(thisBoard) {
        var headerHeight = 44;
        var teamHeight = 68;
        for (var i = 0; i < thisBoard.teamCount; ++i) {
            var teamId = thisBoard.teamNextSequence[i].teamId;
            if(toPos != -1)
                $("div[team-id=\"" + teamId + "\"]").animate({ margin: 0 }, 2200).animate({ top: i * teamHeight + headerHeight }, 1000, function() {
                    thisBoard.noAnimate = true;
                });
            else
                $("div[team-id=\"" + teamId + "\"]").animate({ margin: 0 }, 1800 ,function() {
                    thisBoard.noAnimate = true;
                });
        }
    })(thisBoard);
}

Board.prototype.keydown = function() {
    
    if (this.noAnimate) {
        this.noAnimate = false;
        
        var team = this.UpdateOneTeam();
        if (team) {
            
            var toPos = this.updateTeamSequence();
            
            this.updateTeamStatus(team);
            
            this.moveTeam(toPos);
        } else {
            
            $('.team-item.hold').removeClass("hold");
        }
    }
}
