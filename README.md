触发‘@’功能：只需在‘回帖输入框’输入‘@’符号，就会触发。  
实现的算法：使用正则表达式，来获取两个指定字符串之间的字符串。（正则表达式：$str = '/(?<=@).*?(?= )/';）  


采用队列的方法，来实现‘@’人的功能。  
  

已实现：  
	1、@列表只会出现作者+回复过次帖子的人  
	2、能一次性‘@’一个人或多个人  
	3、被‘@’到的人，会触发发送邮件通知（自己在回复里@自己，不给予消息通知）  
	4、在未读信息列表，显示出这条‘@’的信息（新增视图）  
