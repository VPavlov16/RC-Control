A fully developed website for entertainment. The website represents a online game, where every user has a free 10 minutes for playing, which refresh every 24 hours using PostgreSQL's cron job.
When registered and fully set, the user then selects a RC vehicle (from the page with all the RC's), after chosing desired RC vehicle he starts to control it and play with it. (live video output not developed).
The RC Tank used consists of ESC,2 brushed 540 80T motors, a battery and Arduino D1 Mini. The control of the tank works trough HTTP requests. There is additional glove with finger movement tracking, which based on the bent fingers sends signals to the RC.
The glove is made out of flex sensors, Arduino D1 R32, some 10k resistors and jumper wires.

Used technologies:
 C++,
 PHP,
 HTML,
 CSS,
 JS,
 PostgreSQL,
 pgCron,
 XAMMP,
 VS Code,
 Git

Used hardware:
 Wemos D1 R32,
 Wemos D1 Mini,
 3D Printers,
 10K resistors,
 Flex sensors,
 ESC 2x40A,
 2 brushed 540 80T motors,
 LiPo battery
