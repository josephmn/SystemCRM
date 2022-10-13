using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CDepartamento
    {
        public List<EDepartamento> Listar_Departamento(SqlConnection con)
        {
            List<EDepartamento> lEDepartamento = null;
            SqlCommand cmd = new SqlCommand("ASP_DEPARTAMENTO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEDepartamento = new List<EDepartamento>();

                EDepartamento obEDepartamento = null;
                while (drd.Read())
                {
                    obEDepartamento = new EDepartamento();
                    obEDepartamento.i_iddep = drd["i_iddep"].ToString();
                    obEDepartamento.v_descripcion = drd["v_descripcion"].ToString();
                    lEDepartamento.Add(obEDepartamento);
                }
                drd.Close();
            }

            return (lEDepartamento);
        }
    }
}