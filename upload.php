<?php
array:19 [▼
  "D1" => 1
  "RDN-BGD" => 1
  "PTPM-QA" => 1
  "RDN-PTPM" => 1
  "D2" => 1
  "PTPM-PROD" => 1
  "D5" => 1
  "RJP-BGD" => 1
  "D0" => 1
  "D3" => 1
  "TCT-PKT" => 1
  "TCT-HCTH" => 1
  "RDN_HCTH" => 1
  "TCT-BGD" => 1
  "TCT-NS" => 1
  "RJP" => 1
  "TCT-SALES" => 1
  "TCT-IT" => 1
  "RDN" => 1
]
array:22 [▼
  "PTPM-DEV" => 1
  "GDDN" => 1
  "QA-MEMBER" => 1
  "RDN-DEV" => 1
  "HR-LEAD" => 1
  "PTPM-LEADER" => 1
  "KT-MEMBER" => 1
  "IT-MEMBER" => 1
  "HCKTDN" => 1
  "PTGD" => 1
  "HR-MEMBER" => 1
  "PTPM-SUBLEAD" => 1
  "TGD" => 1
  "SALES-MEMBER" => 1
  "HR-PR" => 1
  "HR-TRANING" => 1
  "VCOO" => 1
  "KT-LEAD" => 1
  "HR-GVTN" => 1
  "CTHDQT" => 1
  "QA -SUBLEAD" => 1
  "HCTH-TV" => 1
]

array:22 [▼
  "PTPM-DEV" => "Developer"
  "GDDN" => "Giám đốc Chi nhánh Đà nẵng"
  "QA-MEMBER" => "Nhân viên QA"
  "RDN-DEV" => "Developer Đà nẵng"
  "HR-LEAD" => "Trưởng phòng nhân sự"
  "PTPM-LEADER" => "Team Leader"
  "KT-MEMBER" => "Nhân viên Kế toán"
  "IT-MEMBER" => "Nhân viên IT"
  "HCKTDN" => "Hành chính Kế toán Đà Nẵng"
  "PTGD" => "Phó giám đốc"
  "HR-MEMBER" => "Nhân viên Nhân sự"
  "PTPM-SUBLEAD" => "Sub Leader"
  "TGD" => "Tổng Giám đốc"
  "SALES-MEMBER" => "Nhân viên Sales"
  "HR-PR" => "Nhân viên PR Nội bộ"
  "HR-TRANING" => "Nhân viên Đào tạo"
  "VCOO" => "Vice COO"
  "KT-LEAD" => "Trưởng phòng Kế toán"
  "HR-GVTN" => "Giáo viên tiếng Nhật"
  "CTHDQT" => "Chủ tịch Hội Đồng Quản Trị"
  "QA -SUBLEAD" => "Phó Phòng QA"
  "HCTH-TV" => "Nhân viên tạp vụ"
]


mm = 1
if (proj.type_mm = '1', , ROUND( / 20, 2)




select proj.id, proj.name, 
if (proj.type_mm = '1', bl.cost_billable_effort, ROUND(bl.cost_billable_effort / 20,2)) as `cost billable`,
if (proj.type_mm = '1', bl.cost_plan_effort_total, ROUND(bl.cost_plan_effort_total / 20, 2)) as `cost plan effort total`,
bl.cost_plan_effort_total_point as `cost plan effort point`,
if (proj.type_mm = '1', bl.cost_plan_effort_current, ROUND( bl.cost_plan_effort_current/ 20, 2)) as `cost plan effort current`,
if (proj.type_mm = '1', bl.cost_resource_allocation_total, ROUND( bl.cost_resource_allocation_total / 20, 2)) as `cost resource allocation total`,
if (proj.type_mm = '1', bl.cost_resource_allocation_current, ROUND( bl.cost_resource_allocation_current/ 20, 2)) as `cost calendar effort current`,
if (proj.type_mm = '1', bl.cost_actual_effort, ROUND( bl.cost_actual_effort/ 20, 2)) as `cost actual effort`,
bl.cost_effort_effectiveness as `cost effectiveness`,
bl.cost_effort_effectiveness_point as `cost effectiveness point`,
bl.cost_effort_efficiency2 as `cost efficiency`,
bl.cost_effort_efficiency2_point as `cost efficiency point`,
bl.cost_busy_rate as `cost busy rate`,
bl.cost_busy_rate_point as `cost busy rate point`,
bl.cost_productivity as `cost productivity`,
bl.qua_leakage_errors as `quality error number leakage`,
bl.qua_leakage as `quality leakage value`,
bl.qua_leakage_point as `quality leakage point`,
bl.qua_defect_errors as `quality error number defect`,
bl.qua_defect as `quality defect value`,
bl.qua_defect_point as `quality defect point`,
ROUND(bl.qua_defect_errors / bl.qua_defect / 20, 2 ) as `effort dev team`,
bl.tl_schedule as `timeliness schedule value`,
bl.tl_schedule_point  as `timeliness schedule point`,
bl.tl_deliver as `timeliness deliverable value`,
bl.tl_deliver_point as `timeliness deliverable point`,
bl.proc_compliance as `process NC value`,
bl.proc_compliance_point as `process NC point`,
bl.proc_report as `process report value`,
bl.proc_report_point as `process report point`,
bl.css_css as `css value`,
bl.css_css_point as `css point`,
bl.point_total as `sumary point`,
concat('Week', ' ', DATE_FORMAT(bl.created_at,'%v %Y-%m-%d')) as `baseline at`,
concat(emp.name , ' - ', emp.email) as PM,
if (proj.type = '1', 'Osdc', 'Base') as `type`,
DATE_FORMAT(proj.start_at,'%Y-%m-%d') as `start date`,
DATE_FORMAT(proj.end_at,'%Y-%m-%d') as `end date`,
DATEDIFF(proj.end_at, proj.start_at) as `duaration (day)`,
GROUP_CONCAT(DISTINCT(programming_languages.name) SEPARATOR ', ') as `programming langage`,
GROUP_CONCAT(DISTINCT(teams.name) SEPARATOR ', ') as `programming langage`
from proj_point_baselines as bl
join projs as proj on proj.id = bl.project_id
join (
    select max(bl_tmp.id) as bl_tmp_id 
    from proj_point_baselines as bl_tmp 
    join projs as proj_tmp on proj_tmp.id = bl_tmp.project_id
    where bl_tmp.created_at >= '2017-01-01 00:00:00' and
    bl_tmp.created_at <= '2017-07-01 00:00:00' and
    proj_tmp.state = 4 and
    proj_tmp.type in (1,2)
    group by proj_tmp.id
) as bl_max_tmp on bl_max_tmp.bl_tmp_id = bl.id
join employees as emp on emp.id = proj.manager_id
left join proj_prog_langs on proj_prog_langs.project_id = proj.id
left join programming_languages on programming_languages.id = proj_prog_langs.prog_lang_id
left join team_projs on team_projs.project_id = proj.id
left join teams on teams.id = team_projs.team_id
where bl.created_at >= '2017-01-01 00:00:00' and
bl.created_at <= '2017-07-01 00:00:00' and
proj.state = 4 and
proj.type in (1,2)
group by proj.id
order by proj.id asc;