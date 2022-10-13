using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VTurno : BDconexion
    {
        public List<ETurno> Listar_Turno(Int32 id, Int32 turno)
        {
            List<ETurno> lCTurno = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CTurno oVTurno = new CTurno();
                    lCTurno = oVTurno.Listar_Turno(con, id, turno);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCTurno);
        }
    }
}