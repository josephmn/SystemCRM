using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VDepartamento : BDconexion
    {
        public List<EDepartamento> Listar_Departamento()
        {
            List<EDepartamento> lCDepartamento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CDepartamento oVDepartamento = new CDepartamento();
                    lCDepartamento = oVDepartamento.Listar_Departamento(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCDepartamento);
        }
    }
}