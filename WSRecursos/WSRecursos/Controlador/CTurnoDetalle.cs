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
    public class CTurnoDetalle
    {
        public List<ETurnoDetalle> Listar_TurnoDetalle(SqlConnection con, Int32 post, Int32 semana, Int32 local, Int32 anhio, String dni)
        {
            List<ETurnoDetalle> lETurnoDetalle = null;
            SqlCommand cmd = new SqlCommand("ASP_TURNOS_DETALLE", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@post", SqlDbType.Int);
            par1.Direction = ParameterDirection.Input;
            par1.Value = post;

            SqlParameter par2 = cmd.Parameters.Add("@semana", SqlDbType.Int);
            par2.Direction = ParameterDirection.Input;
            par2.Value = semana;

            SqlParameter par3 = cmd.Parameters.Add("@local", SqlDbType.Int);
            par3.Direction = ParameterDirection.Input;
            par3.Value = local;

            SqlParameter par4 = cmd.Parameters.Add("@anhio", SqlDbType.Int);
            par4.Direction = ParameterDirection.Input;
            par4.Value = anhio;

            SqlParameter par5 = cmd.Parameters.Add("@dni", SqlDbType.VarChar);
            par5.Direction = ParameterDirection.Input;
            par5.Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lETurnoDetalle = new List<ETurnoDetalle>();

                ETurnoDetalle obETurnoDetalle = null;
                while (drd.Read())
                {
                    obETurnoDetalle = new ETurnoDetalle();
                    obETurnoDetalle.v_dni = drd["v_dni"].ToString();
                    obETurnoDetalle.v_pernombres = drd["v_pernombres"].ToString();
                    obETurnoDetalle.id_local = drd["id_local"].ToString();
                    obETurnoDetalle.i_num_semana = drd["i_num_semana"].ToString();
                    obETurnoDetalle.i_anhio = drd["i_anhio"].ToString();
                    obETurnoDetalle.v_lunes = drd["v_lunes"].ToString();
                    obETurnoDetalle.v_martes = drd["v_martes"].ToString();
                    obETurnoDetalle.v_miercoles = drd["v_miercoles"].ToString();
                    obETurnoDetalle.v_jueves = drd["v_jueves"].ToString();
                    obETurnoDetalle.v_viernes = drd["v_viernes"].ToString();
                    obETurnoDetalle.v_sabado = drd["v_sabado"].ToString();
                    obETurnoDetalle.v_domingo = drd["v_domingo"].ToString();
                    lETurnoDetalle.Add(obETurnoDetalle);
                }
                drd.Close();
            }

            return (lETurnoDetalle);
        }
    }
}