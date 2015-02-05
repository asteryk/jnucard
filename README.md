jnucard
---

面向暨南大学的教务处和校园卡开发的查询api接口

---
## 校园卡查询

###格式

`http://api.liangyuekang.net/card.json`

###传入参数

>userid string 学号
>userpw string 密码
>key string key值

###返回

`{
    "name":"名字",
    "card_id":"学号",
    "money":"余额\u5143"
  }`

---
## 教务处查询课表

###格式

`http://api.liangyuekang.net/course.php`

###传入参数

>id string 学号
>password string 密码
>key string key值

###返回

`no.n: {
	course_name: "课程",
	course_group: "必修课或选修 ",
	course_time: "周几第几节",
	teacher: "老师",
	place: "教室"
	},
	stuname: "姓名"
}`

---
## 教务处查询成绩

###格式

`http://api.liangyuekang.net/grade.php`

###传入参数

>id string 学号
>password string 密码
>key string key值

###返回

`no.n: {
	term: "2014-2015学年上学期",
	course_grade: [
	{
		course_name: "毛泽东思想和中国特色社会主义理论体系概论(上)",
		type: "必修",
		score: "79.0",
		credit_num: "3.00"
	},
	
	],
		final_score: "本学期平均学分绩点:x.xx"
	},
		stuname: "姓名",
		final_avg_score: "最终的平均学分绩点:x.xx"
}`
