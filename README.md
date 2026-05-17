# 🎓 Campus Event Management System
**Database Management Systems Project**

A unified platform to discover, register for, and promote campus events. 

---

## Team Members

- Amina El Guenuni
- Said Hashem Hussaini 

---

## Project Overview

Hood College currently manages campus events across **two separate platforms**: Navigate 360 and Viva Engage (Microsoft). This fragmentation forces students to check multiple sites and offers no unified filtering by category, club, or event type. Management reports are also incomplete, making it harder for student leaders to make informed decisions.

The **Campus Event Management System** solves these problems by providing:

- ✅ A **single, unified** hub for all Hood College events
- ✅ **Category-based filtering** (Academic, Social, Sports, Career, Cultural, Community Service, etc.)
- ✅ Clean, organized data to support student organizations long-term

---

## Live Application

🔗 **[https://pluto2.hood.edu/~team01/project_home.php](https://pluto2.hood.edu/~team01/project_home.php)**

---

## Technology Stack

| Layer | Technology |
|---|---|
| Database | MySQL (hosted on Pluto) |
| Backend | PHP |
| Frontend | HTML, CSS, JavaScript |

---

## Application Pages

| Page | Description |
|---|---|
| **Home** | Central navigation hub welcoming users and linking to all pages |
| **Students Registered for Events** | Displays students alongside the events they've registered for (from `Student` and `Registers` tables) |
| **Events with Organizer & Category** | Lists all events with associated organizer club, category, type, start time, and capacity |
| **Add Event** | Form to insert a new event record (title, description, times, capacity, category, organizer, staff) |
| **Student Event Registration** | Insert operation linking a student to an event via the `Registers` table |
| **Search Events by Category** | Search/filter events by category using query parameters |

---

## Database Schema

### Entities & Tables

```
Student(StudentID, FirstName, LastName, Email, GradYear)
Staff(StaffID, FirstName, LastName, Email, RoleTitle)
OrganizerClub(OrganizerID, OrgName, Type, Email, Phone, Description, StaffID)
Event(EventID, Title, Description, StartTime, EndTime, MaxCapacity, CategoryID, OrganizerID, StaffID)
Category(CategoryID, CategoryName, Description)
Sponsor(SponsorID, SponsorName, ContactEmail, ContactPhone)
Registers(StudentID, EventID)
Sponsors(EventID, SponsorID, Contribution_amount)
```

### Entity Relationship Summary

- A **Student** can register for many **Events** (via `Registers`)
- An **OrganizerClub** hosts many **Events**
- An **Event** belongs to exactly one **Category**
- A **Staff** member can advise a club and optionally coordinate events
- **Sponsors** can fund multiple events with tracked contribution amounts

---

## Acknowledgments

Developed as part of the **Database Management Systems** course at **Hood College**.  
Special thanks to Hood College faculty
