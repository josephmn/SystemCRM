using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantTurno : BDconexion
    {
        public List<EMantenimiento> MantTurno(Int32 id, Int32 semana, Int32 local, Int32 anhio, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantTurno oVMantTurno = new CMantTurno();
                    lCEMantenimiento = oVMantTurno.MantTurno(con, id, semana, local, anhio, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}