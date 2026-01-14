START
    WHEN Start button is pressed
        create new deck
        create player hand
        set game status to "playing"

    WHILE game status is "playing"

        IF player presses "Draw card" THEN
            draw random card from deck
            add card to player hand
            calculate player score

        IF player score > 21 THEN
            set result to "Player loses"
            set game status to "over"
        END IF
    END IF

    IF player presses "Stop" THEN
        dealer draws cards according to rules
        compare player hand with dealer hand

    IF player wins THEN
            set result to "Player wins"
        ELSE
            set result to "Dealer wins"
        END IF

        set game status to "ended"
    END IF
END WHILE

DISPLAY result message
